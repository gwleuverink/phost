<p align="center">
<img src="https://github.com/gwleuverink/phost/blob/main/storage/app/public/icon.png?raw=true" alt="Logo" width="260" />
</p>

<p align="center">
<a href="https://github.com/gwleuverink/phost/actions/workflows/test.yml"><img src="https://github.com/gwleuverink/phost/actions/workflows/test.yml/badge.svg" alt="Tests"></a>
<a href="https://github.com/gwleuverink/phost/actions/workflows/codestyle.yml"><img src="https://github.com/gwleuverink/phost/actions/workflows/codestyle.yml/badge.svg" alt="Codestyle"></a>
</p>

## About

Phost is an email debugging tool and local SMTP server, developed primarily in PHP. It leverages a powerful stack of modern technologies:

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

[Download the latest release here](https://github.com/gwleuverink/phost/releases.)

### Installation on macOS

Please note that the current build is neither signed nor notarized. To run the app for the first time after installation:

1. Locate the app in Finder
2. Control-click (or right-click) the app icon
3. Select 'Open' from the context menu
4. Click 'Open' in the dialog box that appears

This process saves the app as an exception to your security settings. Thereafter, you can launch it by double-clicking, like any other registered app.

### Security Considerations

I understand if you have reservations about running unverified applications. This project is currently in an experimental phase, and I have not yet invested in an Apple Developer Account for code-signing. Future notarization depends on community support through [GitHub Sponsors](https://github.com/sponsors/gwleuverink). Your support is greatly appreciated! 🙏
