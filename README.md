# StegIf

### Created by

## About this project

This project has a Vue frontend and a Laravel backend. The text in the game can be adjusted in `resources/data/dialogue.xlsx` and then `python convert_to_json.py` must be run in the same folder.

The backgrounds used in the game can be found in `public/backgrounds`. They are named as called in the `dialogue.xlsx` file. The characters and their text boxes can be found in `public/characters`.

The game itself can be found in `resources/js/views/Game.vue`.

The data send to the mySQL database can be analysed with the Jupyter Notebook `data_analysis.ipynb`. Most of this code is created by ChatGPT.

### Prerequisites

The installation commands are for Linux. Consider downloading [Windows Subsystem for Linux (WSL)](https://learn.microsoft.com/en-us/windows/wsl/install) if you use Windows. You can then type `wsl` in cmd to use it.

In order to develop this website, you must have php installed. You can do that with the following command:

```
sudo apt install php
```

Check your version with `php -v`. If you have trouble installing a php version 8.2 or higher, you might try running the following commands:

```
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php
# Select the right version if default is not updated (check with php -v if it is good already or not)
sudo update-alternatives --config php
```

You also need `composer` for this project. The installation instructions can be found [here](https://getcomposer.org/download/). Be sure to move the `composer.phar` too, like described.

Install `Node.js` for Linux using `nvm` with the instructions found [here](https://nodejs.org/en/download/package-manager). Use `sudo apt install curl` if you have not installed `curl` yet.

In addition, install the following dependencies:

```
sudo apt install php-xml php-mysql php-curl
```

When you open this project for the first time, be sure to run `composer install` and `npm install` to install the dependencies.

#### For local development

These steps are only needed to be peformed once.

Make a copy of `.env.example` and call it `.env`.

Use `php artisan key:generate` to generate your own application key.

Install and start a MySQL server:

```
sudo apt install mysql-server
sudo systemctl start mysql.service
```

Use `php artisan migrate` to generate your own database. Select 'yes' to create it. Create a user with enough permissions for the database in the `mysql` interface.

Also, update the username and password of that in the `.env`.

Now, everything is ready to be run.

### Run the project

#### Development

To run the project, run the following two commands (possibly in two terminals):

```
php artisan serve
npm run dev
```

#### Docker

To use docker, run the following command:

```
docker compose -f docker-compose.yml up --build
```

When running for the first time, the database still needs its migrations. Use `docker ps` to find the app container name (probably `stegadventure-app-1`) and then use `docker exec -it <container-name> php artisan migrate`. This project has not been optimised for the use of docker.

## Changing the story

To change the story, you can adjust `resources/data/dialogue.xlsx`. In this document, each row should have a unique, self-defined integer id. The character name who says the sentence should be mentioned in the second column. The system will fetch the `text.webp` in the folder of the character in `/public/characters/<character-name>`. The system will also use the drawing of the mentioned character, which is in the same folder as `text.webp`. The `default.webp` picture will be taken by default, but by specifying the emotion in `dialogue.xlsx` (column 3) another drawing can be taken (e.g. 'happy' takes `happy.webp`). Using these features, characters can be changed.

Characters can either just say something (Type = `TEXT`) or ask a question (Type = `QUESTION`). The text or the question can be written in the Content column (5th column). Whenever the Type is `TEXT`, it should be specified which row should be the next frame of the story in the 7th column (Next). The number filled in here is the self-defined id that it should point to. Whenever the Type is `QUESTION`, the Choices column (6th column) should be used. The syntax is as follows: `<option string> -> <to id>; <second option string> -> <to id>`. So, the option displayed should be left of the arrow, and right of the arrow should be the id of the next frame when that option is pressed. Using these features, the story can be fully customised, and even a new story could be implemented.

The Location column specifies a location visible to the user for a more understandable story. The path in the Background column refers to the image used as background. The background images can be found in `/public/backgrounds`.

So, using `dialogue.xlsx` and changing the images, the story can be adjusted and a new game can even be created. By default, the game is hosted in the `/game` path, as `/` is used for the research. You can use the `/story`-path to debug the newly created story, as it shows a directed graph of the story. Do not forget to run `python convert_to_json.py ` in the same folder as `dialogue.xlsx` to recreate the necessary json file for the system.

## Project structure

### Routing

Frontend: Extra visible pages can be added to `resources/js/plugins/router.js` so that the user can access it. Here, you can link a Vue component with a routing path.

Backend: First a match is tried to be found in `routes/web.php`. It is usually the case that only `json` is returned here. If no match is found, the request is forwarded to the frontend (`router.js`), which tries to find a match again.

### Webpages and components

The webpage is a single-page application and its main component is initialised in `resources/js/App.vue`. The global CSS used on Vuetify components can be found there. In addition, it makes use of `resources/css/app.css`.

The visible webpages can be found under `resources/js/views`. These webpages may use either Vuetify components or self-created components. The self-created components can be found in `resources/js/components`. Most components have scoped CSS in them, that only holds for that specific component.

### Database

Data is send to the mySQL database.

## Frameworks used

### Laravel

Laravel documentation can be found [here](https://laravel.com/docs).

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

### Vue

Vue documentation can be found [here](https://vuejs.org/guide/).

In this project, Vue is extended with Vuetify, so pre-made Vuetify components can be used. All Vuetify components can be found [here](https://vuetifyjs.com/en/components/all/).

## AI statement
