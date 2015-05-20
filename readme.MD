# Foundri MVP Dev System

### Setup
* Install Virtual Box, VVV, Composer, Node, Grunt.
* Clone this repo into your local vagrant's WWW
* Reprovision vagrant (be sure if you didn't install vagrant host updater to add the domain)
 * `vagrant provision`
 * Maybe needs a `vagrant halt` and `vagrant up` too.
* cd into the new directory
* Install node dependencies `npm install`
* Composer update (builds the whole site) `composer update`
* Use `grunt composer-plugins` to update dependencies in all plugins.
* http://foundri-mvp.dev should now be a thing.
* 

### Structure & Philosophy
Everything that is unique to this project gets commited here. Everything else uses npm or composer.

Foundri is built into two places:
* `/public_html/foundri-mvp-content/foundri-mvp-themes/foundri-mvp-theme` Presentation layer 
* `/public_html/foundri-mvp-content/mu-plugins` Data layer

### Going Live, wp-config and You
Salts, and DB details should be set in dev-config.php and prod-config.php. If production-config.php exists that will be used. So don't have that in your local dev environment, but manually place it in your live environment. production-config.php is gitignored, and since that's the only thing with sensitive details, the rest of the repo that this project creates should be safe to post publicly.
