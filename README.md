# Revolut Statement

A command-line tool to convert Revolut Trading statements in the PDF format to CSV or Excel.

Hopefully, Revolut will soon develop this as a feature of their own at which time this package will become obsolete.

## Data

The Activity section of your statement is exported. These are the columns that are included:
* Trade Date
* Settle Date
* Currency
* Activity Type
* Symbol / Description
* Symbol
* Description
* Quantity
* Price
* Amount

## Supported Formats

| Format | Details |
| ------ | ------- |
| `csv`  | Comma-separated values file *(default)* |
| `xlsx` | Excel 2007 onwards |
| `ods`  | OpenOffice spreadsheet |
| `xls`  | Legacy Excel format |

## Installation

### Requirements

PHP ≥ 7.2.5

### Installation

Run this one-liner from your shell:
```Bash
php -r "copy('https://github.com/bogdanghervan/revolut-statement/raw/master/builds/revolut-statement', '/usr/local/bin/revolut-statement');" && chmod u+x /usr/local/bin/revolut-statement
```

This will download the latest build from GitHub to a folder that's likely to be in your system path.

You're ready to use Revolut Statement!

## Usage

**Convert a single statement to CSV**

To convert a Revolut stock trade PDF statement to CSV:
```
revolut-statement convert statement-aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee.pdf > my-statement.csv
```

In the example above `statement-aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee.pdf` is a likely name of the PDF statement downloaded from the Revolut app. The command would read the file and convert it to a CSV file named `my-statement.csv`.

**Convert multiple statements to CSV**

You can convert more PDF statements at the same time by specifying a list of files separated by space in the command line:
```
revolut-statement convert statement-aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee.pdf statement-vvvvvvvv-wwww-xxxx-yyyy-zzzzzzzzzzzz.pdf > all-statements.csv
```

In the example above, the two PDF statements would be stitched together in one single CSV file called `all-statements.csv`. Now you can use this file to run analyses on your successful trades or prepare your tax reports.

**Convert a statement to Excel**

To convert a Revolut stock trade PDF statement to Excel:
```
revolut-statement convert statement-aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee.pdf -f xlsx -o my-statement.xlsx
```

**Convert multiple files matching a pattern**

A common use case is wanting to stitch together several PDF stock trade statements downloaded from Revolut in the same directory that have a file name resembling `statement-aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee.pdf`. Here's how to do that simply:
```
revolut-statement convert statement-*.pdf -f xlsx -o all-statements.xlsx -v
```

Pro tip: Pass in the `-v` option to see additional details while files are parsed.

**See all available options**

```
revolut-statement convert --help
```

**Install updates**

You can download the latest version of this app:
```
revolut-statement self-update
```

## Support

Has this just saved you the trouble of having to manually compile all this information? Consider leaving me a note and buying me a coffee by clicking the button below.

[![ko-fi](https://www.ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/B0B325116)

Have you found a problem? [Submit an issue](https://github.com/bogdanghervan/revolut-statement/issues)

## Legal 

Revolut Statement is an open-source software licensed under the [MIT license](https://github.com/bogdanghervan/revolut-statement/blob/master/LICENSE).

The data is processed by Revolut Statement locally without ever leaving your computer. Generally speaking, PDFs can be glitchy or errors in the software can cause the output to be inaccurate. Use it at your own risk!

This program is not affiliated or endorsed in any way by Revolut which is a trademark of Revolut Ltd.  
