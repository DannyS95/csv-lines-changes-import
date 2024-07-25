# Project Guide
 *  This project is created so you can upload two CSV files with the same information, and list unto a table what type of change ocurred in each of the lines.

# Installlation Requirements

* To get he project up and running you need a Linux VM running on your OS, such as WSL, VirtualBox, or Docker Desktop.
* Use git to clone the project.
* Make sure the docker engine is installed and run docker **compose up -d**, and that's all that is needed to make it work.
* After the first main step, please run **make install** in the project root, if you get a connection refused just wait a few seconds until it works.
* After getting the containers running, and having successfully installed the project, just visit [localhost:8080/]() so you can run the tests.

<br>

## Project considerations
* The project was developed using [Inertia](https://inertiajs.com/) with [Vue 3](https://vuejs.org/guide/introduction.html).
* Validations are in place for when we are uploading the CSV, such as required fields, minimum size, and ensuring the size of the file with the newer data is more or the same as the other.
* I build this project to practise the usage of Inertia and Laravel.
* I did not consider handling cases where the the file with recent data has less lines than the older file in the API.
* I did not paginate the API, with the provided files it takes roughly 500MS to respond with 324 line records.

<br>


## Project structure
### Main concepts kept in mind
<ul>
  <li>Dependency Injection</li>
  <li>SRP</li>
  <li>Client-Server Architecture</li>
  <li>REST</li>
  <li>OCP</li>
  <li>LSP</li>
  <li>Iterators</li>
  <li>Specification</li>
</ul>


### Implementation specification
* The main page of the project is in **resources/js/Pages.**
* The routes are defined as per laraveling routing in web.php.
