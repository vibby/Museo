
INSERT INTO `museum` (`id`, `name`, `description`) VALUES (1, 'Le Louvre', "Le musée du Louvre est l’un des plus grands musées du monde et le plus grand musée de Paris par sa surface de 210 000 m2 dont 60 600 consacrés aux expositions4. Situé au cœur de la ville, entre la rive droite de la Seine et la rue de Rivoli, dans le 1er arrondissement, le bâtiment est un ancien palais royal, le palais du Louvre. La statue équestre de Louis XIV constitue le point de départ de l’axe historique, mais le palais n’est pas aligné sur cet axe. Le Louvre possède une longue histoire de conservation artistique et historique de la France, depuis les rois capétiens jusqu’à nos jours.");
INSERT INTO `museum` (`id`, `name`, `description`) VALUES (2, 'Musée du Quai Branly', "Le musée du quai Branly ou musée des arts et civilisations d’Afrique, d’Asie, d’Océanie et des Amériques (civilisations non occidentales) est situé quai Branly dans le VIIe arrondissement de Paris, au pied de la tour Eiffel. Projet ambitieux porté par Jacques Chirac et réalisé par Jean Nouvel, il a été inauguré le 20 juin 2006. La fréquentation moyenne se situe autour de 125 000 visiteurs par mois.");
INSERT INTO `museum` (`id`, `name`, `description`) VALUES (3, 'Musée d’Orsay', "Le musée d’Orsay est un musée national situé à Paris, sur la rive gauche de la Seine, dans le quartier Saint-Thomas-d’Aquin du 7e arrondissement, aménagé dans l’ancienne gare d’Orsay, construite par Victor Laloux (1898) et inauguré en 1986. Les collections du musée présentent la peinture et la sculpture occidentale de 1848 à 19142, ainsi que les arts décoratifs, la photographie et l’architecture.");
INSERT INTO `museum` (`id`, `name`, `description`) VALUES (4, 'Château de Versailles', "Le château de Versailles est un château et un monument historique français qui se situe à Versailles, dans les Yvelines, en France. Il fut la résidence des rois de France Louis XIV, Louis XV et Louis XVI. Le roi et la cour y résidèrent de façon permanente du 6 mai 1682 au 6 octobre 1789, à l’exception des années de la Régence de 1715 à 1723.");
INSERT INTO `museum` (`id`, `name`, `description`) VALUES (5, 'Musée des Beaux Arts de Nantes', "Le musée des beaux-arts de Nantes est créé, comme quatorze autres musées de province, par arrêté consulaire du 14 fructidor de l’an IX (1801). Aujourd’hui, le musée des beaux-arts de Nantes fait partie des cinq grands musées en région, aux côtés de Lyon, Bordeaux, Toulouse et Lille. Il est inscrit au titre des monuments historiques depuis le 29 octobre 19752.");
INSERT INTO `museum` (`id`, `name`, `description`) VALUES (6, 'Centre Georges Pompidou', "Le Centre national d’art et de culture Georges-Pompidou (CNAC), communément appelé « Centre Georges-Pompidou », « Centre Pompidou » ou « Centre Beaubourg » et, familièrement, « Beaubourg », est un établissement polyculturel situé dans le quartier de Beaubourg, dans le 4e arrondissement de Paris, entre le quartier des Halles et le quartier Marais.");
INSERT INTO `museum` (`id`, `name`, `description`) VALUES (7, 'Musée Dobrée', "Le musée départemental Thomas-Dobrée, couramment appelé « musée Dobrée » est situé dans le centre-ville de Nantes, dans le quartier Graslin, à proximité du Muséum d’histoire naturelle et du cours Cambronne, non loin de la médiathèque Jacques-Demy. Ses bâtiments à l’architecture originale abritent de riches collections.");
INSERT INTO `museum` (`id`, `name`, `description`) VALUES (8, 'Museum d’histoire naturelle de Nantes', "Le muséum d’histoire naturelle de Nantes est un musée d’histoire naturelle français situé dans la ville de Nantes, en Loire-Atlantique.");
INSERT INTO `museum` (`id`, `name`, `description`) VALUES (9, 'Château des ducs de Bretagne', "Le château des ducs de Bretagne est un ensemble architectural situé à Nantes, constitué d’un rempart du xve siècle et d’édifices divers bâtis du xive au xviiie siècle, classé monument historique depuis 1840.");

INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (1, 'Musées par status', NULL);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (2, 'Musées nationaux', 1);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (3, 'Musées privés', 1);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (4, 'Musées par type', NULL);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (5, 'Musées d’Art', 4);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (6, 'Art primitif', 5);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (7, 'Art comtemporain', 5);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (8, 'Art baroque', 5);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (9, 'Musées d’histoire naturelle', 4);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (10, 'Musées d’histoire', 4);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (11, 'Musées par région', NULL);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (12, 'Île de France', 11);
INSERT INTO `category` (`id`, `name`, `parentid`) VALUES (13, 'Pays de la Loire', 11);

INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (2, 1);
INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (9, 1);
INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (6, 1);
INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (12, 1);

INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (6, 2);
INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (3, 2);
INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (8, 2);
INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (12, 2);

INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (2, 3);
INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (8, 3);
INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (12, 3);

INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (2, 4);
INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (12, 4);

INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (13, 5);

INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (12, 6);

INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (13, 7);

INSERT INTO `museumcategory` (`category_id`, `museum_id`) VALUES (13, 8);
