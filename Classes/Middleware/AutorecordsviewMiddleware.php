<?php

declare(strict_types=1);

namespace Brightside\Autorecordsview\Middleware;

use Doctrine\DBAL\ParameterType;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Backend\Routing\RouteResult;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\RedirectResponse;

class AutorecordsviewMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly UriBuilder $uriBuilder
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() !== 'GET') {
            return $handler->handle($request);
        }

        $routing = $request->getAttribute('routing');
        if (!$routing instanceof RouteResult) {
            return $handler->handle($request);
        }

        $currentIdentifier = $routing->getRoute()->getOption('_identifier');
        
        if ($currentIdentifier !== 'web_layout' && $currentIdentifier !== 'records') {
            return $handler->handle($request);
        }

        $queryParams = $request->getQueryParams();
        $pageId = (int)($queryParams['id'] ?? 0);

        if ($pageId > 0) {
            $backendUser = $GLOBALS['BE_USER'] ?? null;

            $queryBuilder = $this->connectionPool->getQueryBuilderForTable('pages');
            $forceListMode = $queryBuilder
                ->select('tx_autolistmode_force')
                ->from('pages')
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid', 
                        $queryBuilder->createNamedParameter($pageId, ParameterType::INTEGER)
                    )
                )
                ->executeQuery()
                ->fetchOne();

            // STEP 1: Entering a forced layout destination -> Pivot to List module
            if ($forceListMode && $currentIdentifier === 'web_layout') {
                if ($backendUser !== null) {
                    $backendUser->setAndSaveSessionData('tx_autolistmode_was_forced', true);
                }

                $listUrl = (string)$this->uriBuilder->buildUriFromRoute('records', ['id' => $pageId]);
                return new RedirectResponse($listUrl, 307);
            }
            
            // STEP 2: User clicks away to an unforced standard page from a forced state
            if (!$forceListMode && $currentIdentifier === 'records') {
                $wasForced = $backendUser !== null ? (bool)$backendUser->getSessionData('tx_autolistmode_was_forced') : false;

                if ($wasForced) {
                    if ($backendUser !== null) {
                        $backendUser->setAndSaveSessionData('tx_autolistmode_was_forced', false);
                    }

                    $layoutUrl = (string)$this->uriBuilder->buildUriFromRoute('web_layout', ['id' => $pageId]);
                    return new RedirectResponse($layoutUrl, 307);
                }
            }

            // STEP 3: Handle manual list browsing safety
            if ($forceListMode && $currentIdentifier === 'records') {
                $wasForced = $backendUser !== null ? (bool)$backendUser->getSessionData('tx_autolistmode_was_forced') : false;
                if (!$wasForced && $backendUser !== null) {
                    $backendUser->setAndSaveSessionData('tx_autolistmode_was_forced', false);
                }
            }
        }

        return $handler->handle($request);
    }
}