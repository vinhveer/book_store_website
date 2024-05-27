CREATE PROCEDURE [dbo].[GetUserInformation_admin]
@startFrom INT
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @pageSize INT = 9; -- Số lượng bản ghi trên mỗi trang
    DECLARE @startRow INT = (@startFrom - 1) * @pageSize; -- Số lượng dòng bắt đầu được bỏ qua

    SELECT
        full_name,
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
        user_accounts ua ON ur.user_role_id = ua.user_role_id
	where r.role_id=2
    ORDER BY
        u.user_id
    OFFSET @startRow ROWS
    FETCH NEXT @pageSize ROWS ONLY;
END;
