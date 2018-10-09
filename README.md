LOGIN
-se connecter
-a propos
-legal

HOME
afficher les dernières notifications
-link to all notification
-menu1: historique, chantier, personnes, matériaux
-menu2: paramètres, notifications, nouvelle entrée
-menu2.1: Logout
-menu3 (quickaccess): au choix : new entry, new person (admin), new site (admin), map, link to specifik site, ...

HISTORIQUE
afficher les dernières entrées (voir WorkDay list)
possibilité de trié par date, site, author, worker, validated, flagged(admin)
-menu3 (shortcut): mon historique auteur, mon historique ouvrier

CHANTIERS
afficher la map des chantier actif
afficher les chantier actif (voir Site list)
searchbar
possibilité de trié par date (création, WD récent), proximité (géolocatlisation),Actif, to validate/flagged (admin)
 -menu3 (shortcut): add site (voir Add Site), Site where I worked

PERSONNES
afficher la liste des personne
searchbar
possibilité de trié par type, par entreprise (par chantier)
 -menu3 (shortcut): add person (voir Add Person), Person whis whom I worked

MATERIAUX
(todo)
PARAMETRES
manage données personnelles
manage shortcuts
manage color (darkmode)
choose language

NOTIFICATIONS
nouvelle notifications trié par type (voir notification list)
all non validated WD
all non validated changes (user)
all flagged WD
all non-exported Site with modified Tasks
menu3 : all notifications par ordre chronologique (historique)


WorkDay List------------------
-WD date
-Site shortname
-site name
-WD Author name
-WD workers
	-WD W CTasks 
		(Task name)
		(Duration)
-WD IsValidated
-picto photo? comment? flagged?(admin)

WorkDay Detail-----------------
-WD date
-WD Site shortname
-WD Site name
-WD Site address
-WD Site map (l&l)
-WD Site Active
-WD site client/person
-WD Author name
-WD Workers
	-WD W CTasks 
		(Task name)(Task description)
		(Duration)
-WD IsValidated
-WD Comment
-WD Flags(admin)
-WD Photos
-WD Materials (TODO)
-modify button (author/admin)
-flag button


Add/modify Workday(NEW ENTRY)-----------------

Site List-----------------
-Site shortname
-site name
-site address
-site person responsable
-site active
-last WD (date)
-something to validate? flagged? (admin)
-creation date

Site Detail----------------- CHANTIER SINGLE
-site map
-WD photos
-WD comments
-Site shortname
-site name
-site address
-site person (name + role)
-site active
-WD list
-Task List
-Worker List
-something to validate? flagged? (admin)
-creation date
-modify button (author/admin)
-flag button

Add/modify Site(Admin)-----------------

Task List-----------------
-task number
-task site shortname
-task name
-task description
-task total CT duration (heures cumulées)
-task last wd date

Task Detail-----------------
-task number
-task site shortname
-task name
-task description
-task total CT duration (heures cumulées)
-task workers (date of CT + duration)
-modify button (admin)

Add/modify Task(Admin)-----------------

Person List-----------------
-name + firstname
-company
-types (+picto)

Person Detail (user/worker, admin)-----------------
-name + firstname
-phone 1 et 2
-email
-company 
-types
-picto
-site list (role)
(worker/user)
-active
-language
-CT list (by date)
-modify button (person/admin)
-flag button


Add/modify Person(Admin)-----------------

Notification List-----------------
-date
-type
-origin?(concerne)
-author
-description
-is active

Comment list---------------
-comment
-author
-date




TODO:
add task number
add flagged + comment to WD
add shortcuts to USER
add person category (ouvrier, fournisseur, architecte, client,...) (create pictos)
EASTER EGG (emoji fleur dans le legal -> rainbow background + cat gifs)
add personXsite Role
1 mail / day /week with all notifications not opened
