Frontend plugin SimpleForm needs following files:

.
|-- Classes
|   |-- Controller
|   |   `-- SimpleFormController.php
|   |-- Domain
|   |   `-- Model
|   |       |-- Genre.php
|   |       `-- GenreRepository.php
|   `-- ExtJS
|       |-- Controller
|       |   `-- ActionController.php
|       |-- SettingsService.php
|       `-- Utility.php
|-- Configuration
|   `-- TypoScript
|       `-- ajax.txt (partial)
|-- Resources
|   |-- Private
|   |   |-- Language
|   |   |   `-- extjs.SimpleForm.xml
|   |   `-- Templates
|   |       `-- SimpleForm
|   |           |-- genres.html
|   |           `-- index.html
|   `-- Public
|       `-- Icons
|           `-- icon_tx_mvcextjssamples_domain_model_genre.gif
|-- ext_emconf.php
|-- ext_icon.gif
|-- ext_localconf.php (partial)
|-- ext_tables_static+adt.sql (partial)
|-- ext_tables.php (partial)
`-- ext_tables.sql (partial)