# grappa-moopt-test-env-docker
Quickly set up Docker Test Environment for Grappa and MooPT


# TODO...
- update `grappa-config.yaml` to 2.2.0
- list requirements: docker-compose v. etc...
- preinstall images in `dind`. maybe try:
	```
	service:
	  docker:
		command: >
		  ash -c "docker pull ghcr.io/hsh-elc/grappa-backendplugin-graflap:latest
		  && docker pull ghcr.io/hsh-elc/grappa-backend-dummygrader:latest
		  "
	```



# Getting started 

First run of `docker-compose up` will take a while to config `bitnami-moodle`.
This will create volume-folder below `/volumes/` as well.
Do this attached, so you can see, when it’s done ;)
```
docker-compose up
```
Afterwards just start environment by:
```
docker-compose up -d
```
Check for running by
```
docker-compose ps
```

For logs of specific container just use set container name. Eg:
```
docker logs moodle-moopt
```
(If you would like to follow this log add option `-f`.)

When you’re done at first shutdown with
```
docker-compose down
```

## Access Moodle
Moodle will connect to MariaDB and bootstrap everything. 
Take a coffee until Moodle logs something like "** Moodle setup finished! **" (few minutes on first run).

Since all these services are in the `grappa-network` they can communicate to each other but are not exposed outside this network.
The only container with exposed ports is `moodle-moopt`.
This is available on port `8088`.
So on host-machine browse to `http://localhost:8088` to access Moodle.
In general: `<IP of docker host mashine>:8088`

If it runs on a remote server only with `ssh` permission, tunnel traffic to your localhost by running:
```
ssh -N -L 11235:localhost:8088 <user>@<remote-host>
```
Now access locally by `http://localhost:11235`.

Login with user and password set in `docker-compose.yaml`:
```
user=test
pw=test
```
(These must fit the values in `grappa-config.yaml`)


## Permissions
On Ubuntu it may occurs that there are permission denies.
...
Mariadb needs: `1001/root` (user/group)
...`sudo chown -R 1001 volumes/mariadb_data`
Moodle needs: `daemon/root` (user/group)

Set correct permissions if needed...
```
cd volumes/
sudo ./clear_folders.sh
```
(Note to run this script with `sudo` _and_ within `volumes/`)
In trouble on setup make sure these folder are completely empty (not even a contained `.gitkeep` is allowed 🙄. These folders need to be _empty_).


# Grappa Config
Grappa config is copied from `grappa/grappa-config.yaml` into container at build time.
Edit this file and rebuild container to apply changes:
```
docker-compose stop grappa-tomcat && docker-compose up -d --build grappa-tomcat
```

Webservice `.war`-file is copied from `grappa/grappa-webservice-2.war` into container at build time.
Place updated `.war` here an rebuild container as above.
Note: Filename must fit within `Dockerfile` also.

Tomcat logs are redirected to `sysout` by Bitnami.
Access them by using docker logs:
```
docker logs grappa-tomcat
```

Connect to running grappa-container:
```
docker exec -it grappa-tomcat /bin/bash
```

# MooPT config
To make default settings for MooPT (or Moodle in general), edit file `moopt/defaults.php`.
Find the help in the [Moodle Documentation](https://docs.moodle.org/311/en/Administration_via_command_line#Custom_site_defaults).
Apply setting by rebuilding container:
```
docker-compose stop moodle-moopt && docker-compose up -d --build moodle-moopt
```
(Since bitnami build the `config-for-grappa.php` at first run, altering this file a priori will have no effect.)

# Connect to Dockerd
Since `dind` is build upon an Alpine attach to container with:
```
docker exec -it docker-daemon /bin/ash
```
(Note to use `ash` instead of `bash`.)

# Used images
- Independent Docker-Daemon: [`docker:dind`](https://hub.docker.com/_/docker)
- Bitnami Redis: [`bitnami/redis`](https://hub.docker.com/r/bitnami/redis/)
- Bitnami Tomcat as Baseimage for `grappa-tomcat`: [`bitnami/tomcat`](https://hub.docker.com/r/bitnami/tomcat/)
- Bitnami MariaDB for Moodle: [`bitnami/mariadb`](https://hub.docker.com/r/bitnami/mariadb/)
- Bitnami Moodle as Baseimage for `moodle-moopt`: [`bitnami/moodle:3`](https://hub.docker.com/r/bitnami/moodle)


# Further Ideas:
- make a volume for `host_jvm_bp`s mounting local `.jar` installations into the container
