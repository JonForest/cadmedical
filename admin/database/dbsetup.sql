        create database cadmedical;
        create user 'cadmedicaluser'@'localhost' identified by 'HopperMyD0g';
        GRANT delete ON cadmedical . * TO 'cadmedicaluser'@'localhost';
        GRANT insert ON cadmedical . * TO 'cadmedicaluser'@'localhost';
        GRANT select ON cadmedical . * TO 'cadmedicaluser'@'localhost';
        GRANT update ON cadmedical . * TO 'cadmedicaluser'@'localhost';
        flush privileges;