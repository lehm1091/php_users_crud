INSERT INTO `supertex_lehm`.`users`
VALUES
('1', 'luis@correo.com', '$2y$10$uO.yY2tnGtElJcs/B2zaO.0DfCeoYU8IqLIUdjB//khW/InZpfZhm', 'Luis E', 'Hernandez', '8888-66666', '2020-10-11 20:04:45', '2020-10-11 07:09:13', '1');

INSERT INTO `supertex_lehm`.`users`
VALUES
('3', 'super@correo.com', '$2y$10$uO.yY2tnGtElJcs/B2zaO.0DfCeoYU8IqLIUdjB//khW/InZpfZhm', 'Super', 'User', '5555-5555', '2020-10-11 20:09:58', '2020-10-11 07:09:13', '1'
);

INSERT INTO `supertex_lehm`.`users`
VALUES
('4', 'joe@correo.com', '$2y$10$uO.yY2tnGtElJcs/B2zaO.0DfCeoYU8IqLIUdjB//khW/InZpfZhm', 'joe', 'doe', '8888-8888', '2020-10-11 20:11:08', '2020-10-11 20:07:15', '1'
);
INSERT INTO `supertex_lehm`.`users`
VALUES
('5', 'kathy@correo.com', '$2y$10$uO.yY2tnGtElJcs/B2zaO.0DfCeoYU8IqLIUdjB//khW/InZpfZhm', 'Kathy', 'Herrera', '5555-8888', '2020-10-11 20:11:08', '2020-10-11 20:07:15', '1'
);
INSERT INTO `supertex_lehm`.`roles` VALUES('1', 'ROLE_SUPER_ADMIN', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `supertex_lehm`.`roles` VALUES('2', 'ROLE_ADMIN', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0', '0');
INSERT INTO `supertex_lehm`.`roles` VALUES('3', 'ROLE_USER', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0');

INSERT INTO `supertex_lehm`.`users_roles` VALUES('1', '1');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('3', '1');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('3', '2');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('4', '2');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('1', '3');

INSERT INTO `supertex_lehm`.`users_roles` VALUES('3', '3');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('4', '3');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('5', '3');
/**Todos los usuarios tienen como contraseña "contra" **/
