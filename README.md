# Learnplaces
Learnplaces 2 is a ground up rewritten drop in replacement of 
the old learnplaces plugin.

## Requirements
* Version: ILIAS 5.2 or 5.3
* PHP 7 or higher

## Installation

### Composer
The latest composer release can be downloaded here <https://getcomposer.org/download/>

### Plugin
Start at your ILIAS root directory  

```bash
mkdir -p Customizing/global/plugins/Services/Repository/RepositoryObject  
cd Customizing/global/plugins/Services/Repository/RepositoryObject
git clone https://github.com/studer-raimann/Learnplaces.git
cd ./Learnplaces
php composer.phar install --no-dev
```  
As ILIAS administrator go to "Administration->Plugins" and install/activate the plugin.  

## Update

### Composer
Update composer to the latest version.

Composer update guide <https://getcomposer.org/doc/03-cli.md#self-update-selfupdate->

### Plugin
Start at your ILIAS root directory

```bash
cd Customizing/global/plugins/Services/Repository/RepositoryObject/Learnplaces
git pull
php composer.phar install --no-dev
```

As ILIAS administrator go to "Administration->Plugins" and update/activate the plugin.

## ILIAS Configuration

### Map
The map integration of the plugin has to be enable in ILIAS in order to
use it without warnings.

- Login as administrator into ILIAS
- Navigate to Administration > Third Party Software
- Select the sub tab of the Settings tab
- Enable your preferred map implementation.
- Save the configuration changes

### Rich text editing
ILIAS uses a third party rich text editor called TinyMCE which must be
enabled in order to use the rich text editing functionality of the plugin.

- Login as administrator into ILIAS
- Navigate to Administration > Editing
- Navigate into the TinyMCE Editor tab
- Tick the option "Enable TinyMCE for WYSIWYG Editing"
- Save the configuration changes

## Versioning
We use SemVer for versioning. For the versions available, see the tags on this repository.

## Acknowledgments
[zendframework/zend-diactoros](https://github.com/zendframework/zend-diactoros)

[wapmorgan/file-type-detector](https://github.com/wapmorgan/FileTypeDetector)

[sabre/uri](https://github.com/sabre-io/uri)

[league/flysystem](https://github.com/thephpleague/flysystem)

[intervention/image](https://github.com/Intervention/image)

[phpunit/phpunit](https://github.com/sebastianbergmann/phpunit)

[mockery/mockery](https://github.com/mockery/mockery)

## Contact

studer + raimann ag  
Farbweg 9  
3400 Burgdorf  
Switzerland

info@studer-raimann.ch  
www.studer-raimann.ch 