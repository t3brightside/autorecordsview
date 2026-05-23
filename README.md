# Auto Records View for TYPO3

[![License](https://poser.pugx.org/t3brightside/autorecordsview/license)](LICENSE.txt)
[![Packagist](https://img.shields.io/packagist/v/t3brightside/autorecordsview.svg?style=flat)](https://packagist.org/packages/t3brightside/autorecordsview)
[![Downloads](https://poser.pugx.org/t3brightside/autorecordsview/downloads)](https://packagist.org/packages/t3brightside/autorecordsview)
[![Brightside](https://img.shields.io/badge/by-t3brightside.com-orange.svg?style=flat)](https://t3brightside.com)

Automatically force specific pages or sys-folders to open in the **Records (List)** module instead of the default **Layout (Page)** module.

It features a smart "elastic band" UX: when you navigate to a forced folder, the backend seamlessly switches to the Records view. When you click back to a normal page, it remembers your previous state and smoothly takes you back into the Layout view.

## Install

1.  **Install via Composer:**
    Run the following command in your project root:

        composer require t3brightside/autorecordsview

2.  **Update Database**
3.  **Clear TYPO3 Cache**

## Usage

Edit page properties of any Page or SysFolder in **Behavior** tab. 3. Check the **Force List Module View** checkbox. 4. Save the record.

Clicking this node in the page tree will now instantly route the user to the Records module.

## Sources

- [GitHub](https://github.com/t3brightside/autorecordsview)
- [Packagist](https://packagist.org/packages/t3brightside/autorecordsview)
- [TER](https://extensions.typo3.org/extension/autorecordsview)

## Development & maintenance

[Brightside OÜ – TYPO3 development and hosting specialised web agency](https://t3brightside.com/)
