FROM bitnami/moodle:3.11.6

ARG MOOPT_BRANCH=develop

### Install additional software
# Use `apt-get` in quiet mode and remove caches after to save storage.
RUN apt-get -qq update && apt-get -yq install \
    git \
    && rm -rf /var/lib/apt/lists/* 

# Pull and install MooPT on develop branch
RUN git clone https://github.com/hsh-elc/moodle-qtype_moopt.git /opt/bitnami/moodle/question/type/moopt \
    && git -C /opt/bitnami/moodle/question/type/moopt checkout $MOOPT_BRANCH

RUN git clone https://github.com/hsh-elc/moodle-qbehaviour_immediatemoopt.git /opt/bitnami/moodle/question/behaviour/immediatemoopt \
    && git -C /opt/bitnami/moodle/question/behaviour/immediatemoopt checkout $MOOPT_BRANCH

RUN git clone https://github.com/hsh-elc/moodle-qbehaviour_deferredmoopt.git /opt/bitnami/moodle/question/behaviour/deferredmoopt \
    && git -C /opt/bitnami/moodle/question/behaviour/deferredmoopt checkout $MOOPT_BRANCH

# Copy customized default settings for MooPT
ADD ["defaults.php", "/opt/bitnami/moodle/local/defaults.php"]
