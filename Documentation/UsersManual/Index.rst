.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _users-manual:

Users manual
============

- Install the extension.
- In the direct mail folder, change the TypoScript template.

Here an example of TypoScript setup, for a TemplaVoila based website, encoded in UTF-8:

.. code-block:: typoscript

    page >
    page = PAGE
    page.typeNum = 0

    # The extension will produce a full blown html document based on the html provided
    page.config.disableAllHeaderCode = 1

    # Call the extension
    page.10 = USER
    page.10.userFunc = tx_css2inline_pi1->main

    # Select the style sheets to be taken into consideration
    page.10.css = COA
    page.10.css.10 = FILE
    page.10.css.10.file = fileadmin/templates/wcc-main/css/wcc_main.css
    page.10.css.20 = FILE
    page.10.css.20.file = fileadmin/templates/wcc-main/css/tt_news_news.css
    page.10.css.30 = FILE
    page.10.css.30.file = fileadmin/templates/wccassembly/css/tt_news_news.css

    # Generate the HTML content of the page
    # Head part
    page.10.html.10 = TEXT
    page.10.html.10.wrap = <head>|</head>
    page.10.html.10.value = <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    # Body part
    page.10.html.20 = USER
    page.10.html.20.wrap = <body>|</body>
    page.10.html.20.userFunc = tx_templaVoila_pi1->main_page


It is particularly important to set the proper encoding in the head tag, as it is used in the
conversion process.
