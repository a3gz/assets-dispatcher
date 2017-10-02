# Assets Dispatcher

## Install 

    composer require a3gz/assets-dispatcher 

## How to use 

Please, check out the included demo. 


## What does it do? 

**Assets Dispatcher** offers a way to easily minify-and-cache-once Javascript and CSS assets on-the-fly.

The full sized assets don't need to be below `public_html`; the PHP dispatcher will: 

1. Attempt to dispatch a minified version of the requested asset. 
2. If the above fails, look for the original non-minified file, create the minified version and dispatch the resulting file.

Evidently, Assets Dispatcher isn't the fastest way to serve Javascript/CSS files because even when there's a minified version available, everything is resolved by a PHP program. For this reason the use proposed in the demo may not be a convenient setup.

## Assets Dispatcher as an automated minifier 

An alternative use we can have for **Assets Dispatcher** is that of an automated minifier. Please, take a look at `demo-alt` for details. 

In this setup, instead of using a PHP dispatcher to server the assets, we use it to generate the minified versions of all the resources we want to serve in our pages. In the `demo-alt` we do this via a PHP file that we have to HTTP GET, but in a real situation we would use a cron job instead. 