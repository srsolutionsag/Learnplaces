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

## Versioning
We use SemVer for versioning. For the versions available, see the tags on this repository.

## Contact

studer + raimann ag  
Farbweg 9  
3400 Burgdorf  
Switzerland

info@studer-raimann.ch  
www.studer-raimann.ch 