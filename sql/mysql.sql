-- 
-- Table structure for table `<prefix>_xhttperror_errors`
-- 

CREATE TABLE `xhttperror_errors` (
  `error_id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `error_title`            VARCHAR(250)              DEFAULT NULL,
  `error_statuscode`       VARCHAR(5)       NOT NULL DEFAULT '000',
  `error_text`             TEXT,
  `error_text_html`        INT(1)           NOT NULL DEFAULT 1,
  `error_text_smiley`      INT(1)           NOT NULL DEFAULT 1,
  `error_text_breaks`      INT(1)           NOT NULL DEFAULT 0,
  `error_showme`           INT(1)           NOT NULL DEFAULT 1,
  `error_redirect`         INT(1)           NOT NULL DEFAULT 0,
  `error_redirect_time`    INT(2)           NOT NULL DEFAULT 3,
  `error_redirect_message` VARCHAR(250),
  `error_redirect_uri`     VARCHAR(250),
  PRIMARY KEY (`error_id`)
)
  ENGINE = MyISAM;

-- 
-- Table structure for table `<prefix>_xhttperror_reports`
-- 

CREATE TABLE `xhttperror_reports` (
  `report_id`           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `report_uid`          INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `report_statuscode`   VARCHAR(10)               DEFAULT NULL,
  `report_date`         INT(10)          NOT NULL DEFAULT '0',
  `report_referer`      VARCHAR(250)              DEFAULT NULL,
  `report_useragent`    VARCHAR(250)              DEFAULT NULL,
  `report_remoteaddr`   VARCHAR(250)              DEFAULT NULL,
  `report_requesteduri` VARCHAR(250)              DEFAULT NULL,
  PRIMARY KEY (`report_id`)
)
  ENGINE = MyISAM;
