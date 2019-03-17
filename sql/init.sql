CREATE TABLE markers(
    id INT(11),
    name VARCHAR(60),
    address VARCHAR(80),
    lat FLOAT(10,6),
    lng FLOAT(10,6),
    type VARCHAR(30),
    status VARCHAR(30)
);

INSERT INTO markers(id, name, address, lat, lng, type) VALUES ('1', 'Beman 1', '27 Beman Ln, Troy NY 12180', '42.734589', '-73.664696', 'regular', 'empty');
INSERT INTO markers(id, name, address, lat, lng, type) VALUES ('2', 'Beman 2', '27 Beman Ln, Troy NY 12180', '42.734589', '-73.664696', 'regular', 'empty');
INSERT INTO markers(id, name, address, lat, lng, type) VALUES ('3', 'Beman 3', '27 Beman Ln, Troy NY 12180', '42.734589', '-73.664696', 'recycling', 'empty');
INSERT INTO markers(id, name, address, lat, lng, type) VALUES ('4', 'Brinsmade 1', '36 Brinsmade Terrace, Troy NY 12180', '42.734370', '-73.665364', 'regular', 'empty');
INSERT INTO markers(id, name, address, lat, lng, type) VALUES ('5', 'Beman 2', '36 Brinsmade Terrace, Troy NY 12180', '42.734370', '-73.665364', 'recycling', 'empty');