TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER after_persona_delete\nAFTER DELETE ON persona\nFOR EACH ROW\nBEGIN\n    DELETE FROM usuario WHERE cedula = OLD.cedula;\nEND'
sql_modes=1098907648
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_unicode_ci'
db_cl_names='latin1_swedish_ci'
created=1721155719648278
