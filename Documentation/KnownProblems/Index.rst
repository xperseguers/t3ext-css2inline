.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _known-problems:

Known problems
==============

- Caveats reported by the developers of the Emogrifier class used in this extension:

  - Even with styles inline, certain CSS properties are ignored by certain email clients. For more information,
    review information `here <http://www.xavierfrenette.com/articles/css-support-in-webmail/#properties>`__ and
    `here <http://www.email-standards.org/>`__.
  - Emogrifier only supports CSS1 level selectors and a few CSS2 level selectors (but not all of them). It does not
    support pseudo selectors (Emogrifier works by converting CSS selectors to XPath selectors, and pseudo selectors
    cannot be converted accurately).
  - Finally, Emogrifier parses your CSS selectors *in order*, meaning later selectors will override earlier selectors
    that apply to the same element. Ideally they would be applied in order of *increasing precedence*, but that's not
    supported yet.
