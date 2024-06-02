CREATE PROCEDURE [dbo].[SearchAccount_employee]
    @keyword NVARCHAR(200)
AS
BEGIN
    SELECT
		u.full_name,
        u.email,
		u.image_user,
        r.role_name,
		r.role_id,
		ua.username,
		ua.password,
		u.user_id,
		u.address,
		u.date_of_birth,
		u.gender,
		u.phone
    FROM
        users u
    INNER JOIN
        user_roles ur ON u.user_id = ur.user_id
    INNER JOIN
        roles r ON ur.role_id = r.role_id
	INNER JOIN
		user_accounts ua on ua.user_role_id = ur.user_role_id
    WHERE
		r.role_id=3 and
		(lower(u.full_name) LIKE '%' + lower(trim(@keyword))  + '%'
		OR LOWER(ua.username) LIKE '%' + lower(trim(@keyword))  + '%'
		OR LOWER(u.email) LIKE '%' + lower(trim(@keyword)) + '%'
		OR LOWER(u.full_name COLLATE Vietnamese_CI_AI) LIKE '%' + lower(trim(@keyword)) + '%'
		OR LOWER(REPLACE(u.full_name COLLATE Vietnamese_CI_AI,' ','')) LIKE '%' + lower(replace(@keyword,' ','')) + '%');
END;
