CREATE TABLE sales_account(
	id bigint IDENTITY(1,1) NOT NULL,
	sales bigint NULL DEFAULT 1,
	check_location_id bigint NULL DEFAULT 0,
	check_date bigint NULL DEFAULT 0,
	check_dateTime bigint NULL DEFAULT 0,
	check_lat nvarchar(30) NULL,
	check_long nvarchar(30) NULL,
	check_user_id bigint NULL DEFAULT 0,
	check_import bigint NULL DEFAULT 0,
	check_update bigint NULL DEFAULT 0,
	check_status bigint NULL DEFAULT 1,
	check_token nvarchar(100) NULL DEFAULT 1,
    PRIMARY KEY CLUSTERED (
        id ASC
    )
)


CREATE TABLE public_holidays(
	id bigint IDENTITY(1,1) NOT NULL,
	dateOff date NULL,
	dateTitle nvarchar(250) NULL,
	dateStatus bigint NULL DEFAULT 1,
    PRIMARY KEY CLUSTERED (
        id ASC
    )
)
insert into public_holidays(dateOff,dateTitle,dateStatus) values
('2023-01-02','วันขึ้นปีใหม่',1),
('2023-03-06','วันมาฆบูชา',1),
('2023-04-06','วันจักรี',1),
('2023-04-06','วันจักรี',1),
('2023-04-13','วันสงกรานต์',1),
('2023-04-14','วันสงกรานต์',1),
('2023-05-01','วันแรงงานแห่งชาติ',1),
('2023-05-04','วันฉัตรมงคล',1),
('2023-06-05','ชดเชยวันเฉลิมพรัชนมพรรษา สมเด็จประนางเจ้าสุทิดา พัชรสุธาพิมลลักษณ พระบรมราชินี',1),
('2023-07-28','วันเฉลิมพระชนมพรรษา พระบาทสมเด็จพระเจ้าอยู่หัว (ร.10)',1),
('2023-08-01','วันอาสาฬหบูชา',1),
('2023-08-14','ชดเชยวันเฉลิมพระชนมพรรษา สมเด็จพระนางเจ้าสิริกิติ์',1),
('2023-10-13','วันคล้ายวันสวรรคต บรมนามบพิตร (ร.9)',1),
('2023-10-23','วันปิยมหาราช',1),
('2023-12-05','วันเฉลิมพระชนมพรรษา พระบาทสมเด็จพระเจ้าอยู่หัว (ร.9)',1),
('2023-12-11','ชดเชยวันรัฐธรรมนูญ',1),
('2023-12-29','ชยเชยวันสิ้นปี',1)

