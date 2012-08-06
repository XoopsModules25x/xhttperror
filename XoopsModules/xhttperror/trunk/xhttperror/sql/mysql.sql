-- 
-- Table structure for table `<prefix>_xhttperror_errors`
-- 

CREATE TABLE `xhttperror_errors` (
    `error_id`                  int(10) unsigned NOT NULL auto_increment,
    `error_title`               varchar(250) default NULL,
    `error_statuscode`          varchar(5) NOT NULL default '000',
    `error_text`                text,
    `error_text_html`         int(1) NOT NULL default 1,
    `error_text_smiley`       int(1) NOT NULL default 1,
    `error_text_breaks`       int(1) NOT NULL default 0, 
    `error_showme`              int(1) NOT NULL default 1,
    `error_redirect`            int(1) NOT NULL default 0,
    `error_redirect_time`       int(2) NOT NULL default 3,
    `error_redirect_message`    varchar(250),
    `error_redirect_uri`        varchar(250),
    PRIMARY KEY  (`error_id`)
) ENGINE=MyISAM;

-- 
-- Table structure for table `<prefix>_xhttperror_reports`
-- 

CREATE TABLE `xhttperror_reports` (
    `report_id`                 int(10) unsigned NOT NULL auto_increment,
    `report_uid`                int(10) unsigned NOT NULL default '0',
    `report_statuscode`         varchar(10) default NULL,
    `report_date`               int(10) NOT NULL default '0',
    `report_referer`            varchar(250) default NULL,
    `report_useragent`          varchar(250) default NULL,
    `report_remoteaddr`         varchar(250) default NULL,
    `report_requesteduri`       varchar(250) default NULL,
    PRIMARY KEY  (`report_id`)
) ENGINE=MyISAM;
