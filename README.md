# CSS to inline converter for direct mail

This is the official repository for [css2inline](https://extensions.typo3.org/extension/css2inline/).

Since the release of v0.2.0 to TER and packagist, the underlying library [emogrifier](https://github.com/MyIntervals/emogrifier)
is now updated and referenced via composer.

This makes this extension now a complete duplicate of the other TYPO3 extension [emogrifier](https://extensions.typo3.org/extension/emogrifier/)
and will as such probably not be maintained anymore.

**YOU ARE ADVISED TO UPDATE YOUR TYPOSCRIPT CONFIGURATION AND SWITCH NOW TO EXT:emogrifier**.

This basically means replacing

```
page.10 = USER
page.10.userFunc = tx_css2inline_pi1->main
```

by

```
page.10 = EMOGRIFIER
```

for your newsletter definition :)
