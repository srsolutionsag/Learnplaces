# Learnplaces
Learnplaces 2 is a ground up rewritten drop in replacement of 
the old learnplaces plugin.

## Requirements
* Version: ILIAS 5.4 or 6
* PHP 7.0 - 7.4

### Compatibility Table
|Plugin Version   | ILIAS Versions | PHP Versions  |
|---|---|---|
| v1.X  | 5.2 - 5.3 | 7.0 |
| v2.X | 5.3 - 5.4 | 7.0 - 7.2 |
| v3.X | 5.4 - 6 | 7.0 - 7.4 |

## Installation

### Composer
The latest composer 1.x release can be downloaded here <https://getcomposer.org/composer-1.phar>

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

### Check the PHP requirements
```bash
cd Customizing/global/plugins/Services/Repository/RepositoryObject/Learnplaces
sphp compoer.phar check-platform-reqs --no-dev
```  

The output should look similar to this:
```
ext-fileinfo  7.4.11    success  
php           7.4.11    success 
```

## Update

### Composer
Update composer to the latest 1.x version.

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

## License
This project is licensed under the GNU GPLv3 License - see the LICENSE.md file for details.

## Acknowledgments
[composer](https://getcomposer.org/)

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

[info@studer-raimann.ch](mailto:info@studer-raimann.ch)  
<https://www.studer-raimann.ch>