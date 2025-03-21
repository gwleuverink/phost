<p align="center">
<img src="https://github.com/gwleuverink/phost/blob/main/storage/app/public/icon.png?raw=true" alt="Logo" width="260" />
</p>

<p align="center">
<a href="https://github.com/gwleuverink/phost/actions/workflows/test.yml"><img src="https://github.com/gwleuverink/phost/actions/workflows/test.yml/badge.svg" alt="Tests"></a>
<a href="https://github.com/gwleuverink/phost/actions/workflows/codestyle.yml"><img src="https://github.com/gwleuverink/phost/actions/workflows/codestyle.yml/badge.svg" alt="Codestyle"></a>
</p>


## About

Phost is a email debugging tool and local SMTP server, developed primarily in PHP. 
Instead of sending your development emails to Mailtrap or MailHog, you can use Phost to debug your emails inside a beautiful self-contained desktop app.

We leverage a powerful stack of modern technologies:

-   [**Laravel/Livewire**](https://livewire.laravel.com/) -> For dynamic, reactive interface
-   [**NativePHP**](https://nativephp.com/) -> Electron wrapper for PHP built apps
-   [**ReactPHP**](https://reactphp.org/) -> Powering the SMTP server component

While Phost may not yet match the feature set (or stability) of some paid alternatives, it serves as an exploration of the capabilities of a native PHP stack.

<img src="https://github.com/gwleuverink/phost/blob/main/storage/app/public/screenshots/filled-inbox.png?raw=true" alt="Filled inbox screenshot" />
<img src="https://github.com/gwleuverink/phost/blob/main/storage/app/public/screenshots/settings.png?raw=true" alt="User preferences screenshot" />
<!-- <img src="https://github.com/gwleuverink/phost/blob/main/storage/app/public/screenshots/inbox-zero.png?raw=true" alt="Inbox zero! screenshot" /> -->

## Features

-   Local SMTP server for intercepting and viewing emails
-   User-friendly interface for email inspection
-   Debug email source, both HTML, text & headers
-   Bookmark emails for quick access
-   Light & dark color schemes
-   Print emails as PDF

## Getting started

At present, only a macOS build is available. Windows and Linux builds are pending due to lack of testing environments. Contributions from users with access to these platforms are more than welcome.

[Download the latest release here](https://github.com/gwleuverink/phost/releases).

## Supporting the Project

To distribute Phost on macOS, the application needs to be signed and notarized through the Apple Developer Program, which costs €100 annually. If you find Phost useful, please consider supporting its development and maintenance through [GitHub Sponsors](https://github.com/sponsors/gwleuverink). Your support helps cover these costs and enables continued development of this open-source tool.
