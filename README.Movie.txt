Frontend plugin Movie needs following files:

.
|-- Classes
|   |-- Controller
|   |   `-- MovieController.php
|   |-- Domain
|   |   `-- Model
|   |       |-- Movie.php
|   |       `-- MovieRepository.php
|   `-- ExtJS
|       |-- Controller
|       |   `-- ActionController.php
|       `-- SettingsService.php
|-- Configuration
|   |-- FlexForms
|   |   `-- Twitter.xml
|   `-- TCA
|       `-- tca.php
|-- Resources
|   |-- Private
|   |   |-- Languages
|   |   |   `-- locallang_db.xml
|   |   `-- Templates
|   |       `-- Movie
|   |           `-- index.html
|   `-- Public
|       `-- Icons
|           `-- icon_tx_mvcextjssamples_domain_model_movie.gif
|-- ext_emconf.php
|-- ext_icon.gif
|-- ext_localconf.php (partial)
|-- ext_tables_static+adt.sql
|-- ext_tables.php (partial)
`-- ext_tables.sql