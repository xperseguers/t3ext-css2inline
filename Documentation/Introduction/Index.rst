.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _introduction:

Introduction
============


.. _introduction-what-does-it-do:

What does it do?
----------------

E-mail clients have a very limited support of CSS. In most cases, they don't support linked
stylesheets. Inline stylesheets are often not supported as well. Inline styles are better
understood.

This utility, based on Emogrifier ( http://www.pelagodesign.com/sidecar/emogrifier/ ), will
“automagically transmogrify your HTML by parsing your CSS and inserting your CSS definitions into
tags within your HTML based on your CSS selectors”.

It is configured by TypoScript, and is to be applied on pages used to prepare Direct Mails.

**Important note** : This extension uses the DOMDocument class and requires PHP 5+. The php-xml
module has to be included in the php installation.


.. _introduction-screenshots:

Screenshots
-----------

Not much to show here, obviously, because everything happens under the hood. The pages should look
the same with inline styles. Only the code will change.

**Example of original HTML code:**

.. code-block:: html

    ...

    <style>
    #textarea {width:641px;margin-top:10px;margin-left:20px;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;}
    .csc-header h1 {font:bold 18px Verdana, Arial, Helvetica, sans-serif;color:#006600;}
    </style>

    ...

    <div id="textarea">
        <div class="csc-header csc-header-n1"><h1 class="csc-firstHeader">EDITORIAL</h1></div>
    </div>



**Code with inline styles:**

.. code-block:: html

    <div id="textarea" style="width:641px;margin-top:10px;margin-left:20px;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;">
        <div class="csc-header csc-header-n1">
            <h1 class="csc-firstHeader" style="font:bold 18px Verdana, Arial, Helvetica, sans-serif;color:#006600;">EDITORIAL</h1>
        </div>
    </div>
