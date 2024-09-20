# Cosmic Chronicals

This project sets up a WordPress environment for the Cosmic Chronicals workshop. You can choose between two methods to run the project: Docker or WordPress Playground.

## Getting Started

### Option 1: Docker

Before you begin, make sure you have Docker and Docker Compose installed on your system.

#### Available Docker Scripts

We provide several scripts to manage the Docker environment:

1. `docker_start.sh`: Starts the WordPress environment.
2. `docker_stop.sh`: Stops the running containers.
3. `docker_reset.sh`: Resets the environment to its initial state.
4. `docker_cleanup.sh`: Removes all Docker resources related to this project.

Once the Docker environment is running, you can access the WordPress site at `http://localhost:9876`.

### Option 2: WordPress Playground

WordPress Playground allows you to run WordPress in your browser using WebAssembly. This method doesn't require Docker and provides a quick, zero-setup environment.

#### Available Playground Scripts

1. `playground_start.sh`: Starts the WordPress Playground environment.
2. `playground_reset.sh`: Resets the Playground environment to its initial state.

To use WordPress Playground, you need to have `npx` installed ( which typically comes with Node.js ).

#### Advantages of Playground

- No Docker required
- Runs directly in your browser
- Quick setup and reset

#### Limitations of Playground

- Doesn't provide a full object cache

To start the Playground environment, run:

```bash
./playground_start.sh
```

To reset the Playground environment, run:

```bash
./playground_reset.sh
```

## Accessing the Site

- For Docker: Visit `http://localhost:9876`
- For Playground: The script will provide a local URL to access the site in your browser

Enjoy building with Cosmic Chronicals!