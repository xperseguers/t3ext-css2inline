.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _configuration:

Configuration
=============

.. _configuration-reference:

Reference
---------

Reference (TypoScript setup)

================  ==========  =======================================================  ========
Property:         Data type:  Description:                                             Default:
================  ==========  =======================================================  ========
css               cObject     The style sheets to be taken into consideration.         none

                              This is totally flexible.  **Example with external
                              files:**

                              page.10.css = COA
                              page.10.css.10 = FILE
                              page.10.css.10.file = fileadmin/templates/wcc-main/css/
                              wcc_main.css

                              page.10.css.20 = FILE
                              page.10.css.20.file = fileadmin/templates/wcc-main/css/
                              tt_news.css

                              **Example with styles from inside TypoScript:**

                              page.10.css.10 = TEXT
                              page.10.css.10.value (
                                 .bodytext {
                                     font: normal 12px Arial, Helvetica,
                                           Verdana, sans-serif;
                                     margin-bottom: 12px;
                                 }
                              )

----------------  ----------  -------------------------------------------------------  --------
html              cObject     Same principle.                                          None

                              **Simple example with templaVoila:**

                              page.10.html = USER

                              page.10.html.userFunc =
                                  tx_templaVoila_pi1->main_page

                              **Example with old page mode:**

                              page.10 = TEMPLATE

                              etc.

                              In the above example, only the content of the body tag
                              is provided. Css2inline will build the whole html
                              document, and assume an iso-8859-1 encoding.

                              For other encodings, all you need to do is to provide a
                              more complete html, including a head tag with encoding
                              information.

                              **Example with utf-8 encoding:**

                              \# Head part

                              page.10.html = COA

                              page.10.html.10 = TEXT

                              page.10.html.10.wrap = <head>|</head>

                              page.10.html.10.value = <meta http-equiv="Content-Type"
                              content="text/html; charset=utf-8" />

                              \# Body part

                              page.10.html.20 = USER

                              page.10.html.20.wrap = <body>|</body>

                              page.10.html.20.userFunc =
                              tx_templaVoila_pi1->main_page

                              **It is also possible to define the html document
                              type**

                              page.10.html.5 = TEXT

                              page.10.html.5.value (

                              <!DOCTYPE html
                              PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                              //www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                              <?xml version="1.0" encoding="utf-8"?>
                              <html xmlns="http://www.w3.org/1999/xhtml">

                              )

                              page.10.html.10 = TEXT

                              page.10.html.10.value = <head><meta
                              http-equiv="Content-Type" content="text/html;
                              charset=utf-8"/></head>

                              page.10.html.20 = USER

                              page.10.html.20.userFunc =
                              tx_templaVoila_pi1->main_page

                              page.10.html.20.wrap = <body>|<body>

                              page.10.html.30 = TEXT

                              page.10.html.30.value = </html>

                              Don't forget to set the doctype in TYPO3 as well, using
                              the **config.doctype**  or **page.config.doctype**
                              directive, see the TSRef manual. This setting impacts
                              how typo3 generates html.
================  ==========  =======================================================  ========

[tsref:(cObject).tx_css2inline_pi1]
