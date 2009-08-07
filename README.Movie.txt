Frontend plugin Movie needs following files:

.
|-- Classes
|   |-- Controller
|   |   |-- GenreController.php
|   |   `-- MovieController.php
|   `-- Domain
|       |-- Model
|       |   |-- Genre.php
|       |   `-- Movie.php
|       `-- Repository
|           |-- GenreRepository.php
|           `-- MovieRepository.php
|-- Configuration
|   |-- FlexForms
|   |   `-- Twitter.xml
|   `-- TCA
|       `-- tca.php
|-- Configuration
|   `-- TypoScript
|       `-- ajax.txt (partial)
|-- Resources
|   |-- Private
|   |   |-- Languages
|   |   |   |-- extjs.Movie.xml
|   |   |   `-- locallang_db.xml
|   |   `-- Templates
|   |       `-- Movie
|   |           |-- genres.html
|   |           |-- index.html
|   |           `-- movies.html
|   `-- Public
|       |-- Icons
|       |   |-- icon_tx_mvcextjssamples_domain_model_genre.gif
|       |   |-- icon_tx_mvcextjssamples_domain_model_movie.gif
|       |   |-- movie_delete.png
|       |   `-- movie_add.png
|       `-- Images
|           `-- movie-1.jpg .. movie-8.jpg
|-- ext_emconf.php
|-- ext_icon.gif
|-- ext_localconf.php (partial)
|-- ext_tables_static+adt.sql
|-- ext_tables.php (partial)
`-- ext_tables.sql