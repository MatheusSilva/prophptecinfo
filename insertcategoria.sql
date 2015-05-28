INSERT INTO `time`.`categoria`
(`codigo_categoria`,
`nome`)
VALUES
((select max(`codigo_categoria`)+1 from time.categoria as codigo),
(select concat('abcdefghijlkmnopqrstuvxyz99', '-' , max(`codigo_categoria`)+1) from time.categoria as codigo));