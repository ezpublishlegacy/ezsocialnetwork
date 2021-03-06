CREATE TABLE `ezsocialnetwork` (
    `id` int NOT NULL AUTO_INCREMENT,
    `site_id` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `url` varchar(255) NOT NULL,
    `hash_url` varchar(32) NOT NULL,
    `class_identifier` varchar(32) NOT NULL,
    `image` varchar(255) NOT NULL,
    `ezpublishstats_id` int(11) NOT NULL,
    `delicious_id` int(6) NOT NULL,
    `googleplus_id` int(6) NOT NULL,
    `reddit_id` int(6) NOT NULL,
    `facebook_id` int(6) NOT NULL,
    `linkedin_id` int(6) NOT NULL,
    `stumbleupon_id` int(6) NOT NULL,
    `twitter_id` int(6) NOT NULL,
    `pinterest_id` int(6) NOT NULL,
    `date_create` int(11) NOT NULL,
    `date_add` int(11) NOT NULL,
    `date_modified` int(11) NOT NULL,
    PRIMARY KEY(id)
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';

CREATE TABLE `ezsocialnetwork_author` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `date_add` int(11) NOT NULL,
    `date_modified` int(11) NOT NULL,
    PRIMARY KEY(id)
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';

CREATE TABLE `ezsocialnetwork_dashboard_author` (
    `dashboard_id` int(11) NOT NULL,
    `author_id` int(11) NOT NULL
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';

CREATE TABLE `ezsocialnetwork_site` (
    `id` int NOT NULL AUTO_INCREMENT,
    `site` varchar(255) NOT NULL,
    `date_add` int(11) NOT NULL,
    `date_modified` int(11) NOT NULL,
    PRIMARY KEY(id)
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';

CREATE TABLE `ezsocialnetwork_facebook` (
    `id` int NOT NULL AUTO_INCREMENT,
    `share_count` int(6) NOT NULL,
    `like_count` int(6) NOT NULL,
    `comment_count` int(6) NOT NULL,
    `total_count` int(6) NOT NULL,
    `click_count` int(6) NOT NULL,
    `commentsbox_count` int(6) NOT NULL,
    `date_add` int(11) NOT NULL,
    `date_modified` int(11) NOT NULL,
    PRIMARY KEY(id)
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';

CREATE TABLE `ezsocialnetwork_ezpublish` (
    `id` int NOT NULL AUTO_INCREMENT,
    `visit_count` int(6) NOT NULL,
    `date_add` int(11) NOT NULL,
    `date_modified` int(11) NOT NULL,
    PRIMARY KEY(id)
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';

CREATE TABLE `ezsocialnetwork_google` (
    `id` int NOT NULL AUTO_INCREMENT,
    `count` int(6) NOT NULL,
    `date_add` int(11) NOT NULL,
    `date_modified` int(11) NOT NULL,
    PRIMARY KEY(id)
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';
