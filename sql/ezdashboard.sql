CREATE TABLE `ezdashboard` (
    `id` int NOT NULL,
    `site_id` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `url` varchar(255) NOT NULL,
    `hash_url` varchar(32) NOT NULL,
    `image` varchar(255) NOT NULL,
    `creator_object_id` int(6) NOT NULL,
    `delicious` int(6) NOT NULL,
    `google_id` int(6) NOT NULL,
    `reddit_id` int(6) NOT NULL,
    `facebook_id` int(6) NOT NULL,
    `linkedin` int(6) NOT NULL,
    `stumbleupon` int(6) NOT NULL,
    `twitter` int(6) NOT NULL,
    `pinterest` int(6) NOT NULL,
    `date_add` int(11) NOT NULL,
    `date_modified` int(11) NOT NULL
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';

CREATE TABLE `ezdashboard_site` (
    `id` int NOT NULL,
    `site` varchar(255) NOT NULL,
    `date_add` int(11) NOT NULL,
    `date_modified` int(11) NOT NULL
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';

CREATE TABLE `ezdashboard_facebook` (
    `id` int NOT NULL,
    `share_count` int(6) NOT NULL,
    `like_count` int(6) NOT NULL,
    `comment_count` int(6) NOT NULL,
    `total_count` int(6) NOT NULL,
    `click_count` int(6) NOT NULL,
    `commentsbox_count` int(6) NOT NULL,
    `date_add` int(11) NOT NULL,
    `date_modified` int(11) NOT NULL
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';

CREATE TABLE `ezdashboard_google` (
    `id` int NOT NULL,
    `count` int(6) NOT NULL,
    `date_add` int(11) NOT NULL,
    `date_modified` int(11) NOT NULL
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';
