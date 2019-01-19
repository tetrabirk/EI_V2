$(document).ready(function()
{
    //array de container
    $ct_containers = $('[id^=work_day2_workers_][id $=_completedTasks]');


    $ct_containers.each(function()
    {
        $container = $(this);
        // où en est l'index ?
        var index = $container.find(':input').length;
        // pas encore de CT -> on en ajoute une
        if (index === 0) {
            index = addCompletedTask($container, index);
        } else {
            // S'il existe déjà des CT, on ajoute un lien de suppression pour chacune d'entre elles
            $container.children('div').each(function() {
                addDeleteLink($(this));
            });
        }
        //ajout d'un bouton 'ADD CT'
        addAddLink($container);

    });

    // La fonction qui ajoute un formulaire CT
    function addCompletedTask($container, $index) {
        $index = parseInt($index);
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var template = $container.attr('data-prototype')
            //TODO recupérer le nom traduit pour le label
            .replace(/__name__label__/g, 'CT n°' + ($index+1))
            .replace(/__name__/g,        $index)
        ;

        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);

        // On ajoute au prototype un lien pour pouvoir supprimer la CT
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        $index++;
        return $index;
    }

    // La fonction qui ajoute un lien de suppression d'une CT
    function addDeleteLink($prototype) {
        // Création du lien
        var $deleteLink = $('<a href="#" class="delete_completed_task btn btn-danger">Supprimer</a>');

        // Ajout du lien
        $prototype.append($deleteLink);

        // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
        $deleteLink.click(function(e) {
            $prototype.remove();

            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
    }

    // La fonction qui ajoute un lien de d'ajout d'une CT

    function addAddLink($container){
        // Création du lien
        var $addLink = $('<a href="#" class="add_completed_task btn btn-default">Add Completed Task\n</a>');

        // Ajout du lien
        $container.after($addLink);
    }

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $( ".add_completed_task" ).click(function(e) {

        //recupération de l'index worker
        var container = e.target.previousSibling;
        var regex1 = /(?<=work_day2_workers_).*(?=_completedTasks)/;
        var workerIndex =  (container.id.match(regex1))[0];


        //récupération de la derniere CT
        var lastCT = $('#work_day2_workers_'+workerIndex+'_completedTasks > div:last-of-type > div:first-of-type')[0];

        //si il n'y a pas de CT on fixe l'index à 0

        if (lastCT === undefined){
            CTindex = 0;
        }else{
            //récupération de l'index CT
            var regex2 = /(?<=work_day2_workers_._completedTasks_).*/;
            var CTindex = parseInt((lastCT.id.match(regex2))[0]);
            CTindex++;

        }

        //preparation des variables à envoyer à addCompletedTask
        var $container = $('#work_day2_workers_'+workerIndex+'_completedTasks');
        addCompletedTask($container,CTindex);
    });


});

