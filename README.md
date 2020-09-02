# Revolut Statement

A command-line tool to parse Revolut Trading statements in the PDF format to CSV, a tabular format that can be opened by your spreadsheets software.

Hopefully, Revolut will soon develop this as a feature of their own at which time this package will become obsolete.

## Data

These are the columns that are included:
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

## Installation

### Requirements

PHP: `^7.2.5`

### Installation

Run this one-liner from your shell:
```Bash
php -r "copy('https://github.com/bogdanghervan/revolut-statement/raw/master/builds/revolut-statement', '/usr/local/bin/revolut-statement');" && chmod u+x revolut-statement
```

This will download the latest build from GitHub and place in a folder that's it likely to be in your PATH.

You're ready to use Revolut Statement!

## Usage

### Single File

To convert a Revolut stock trade PDF statement to CSV:
```
revolut-statement convert statement-aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee.pdf > my-statement.csv
```

In the example above `statement-aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee.pdf` is a likely name of the PDF statement downloaded from the Revolut app. The command would read the file and convert it to a CSV file named `my-statement.csv`.

### Multiple Files

You can convert more PDF statements by specifying a list of files separated by space in the command line:
```
revolut-statement convert statement-aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee.pdf statement-vvvvvvvv-wwww-xxxx-yyyy-zzzzzzzzzzzz.pdf > all-statements.csv
```

In the example above, the two PDF statements would be stitched together in one single CSV file called `all-statements.csv`. Now you can use this file to run analyses on your successful trades or prepare your tax reports.

## Legal 

Revolut Statement is an open-source software licensed under the [MIT license](https://github.com/bogdanghervan/revolut-statement/blob/stable/LICENSE).

The data is processed by Revolut Statement locally without ever leaving your computer. Generally speaking, PDFs can be glitchy or errors in the software can cause to output to be inaccurate. Use on your own risk!

This program is not affiliated or endorsed in any way by Revolut which is a trademark of Revolut Ltd.  
