document.addEventListener('DOMContentLoaded', function()
{
    const forumContainer = document.querySelector('.Liste_run');

    forumContainer.addEventListener('mouseover', function(event)
    {
        const post = event.target.closest('.forum_post');
        if (post)
        {
            post.style.border = "3px solid #000";
            post.style.cursor = "pointer";
        }
    });

    forumContainer.addEventListener('mouseout', function(event)
    {
        const post = event.target.closest('.forum_post');
        if (post)
        {
            post.style.border = "3px solid #a53d2a";
            post.style.cursor = "default";
        }
    });

    forumContainer.addEventListener('click', function(event)
    {
        const postDisplaySection = document.querySelector('.post_display');
        const postsArea = event.target.closest('.posts_area');
        const post = event.target.closest('.forum_post');
        const boutonAjout = document.querySelector('.bouton_creation_post');
        const alterPost = document.querySelector('.alter_post');

        if (!post)
        {
            return;
        }

        if(postsArea)
        {
            postsArea.style.display = 'none';
            postsArea.style.padding = "0px";
            postDisplaySection.style.display = 'flex';
            boutonAjout.style.display = 'none';
        }

        if (post)
        {
            const attributes = JSON.parse(post.getAttribute('data-attributes'));

            document.getElementById('titre_post').textContent = attributes.titre_post;
            document.getElementById('auteur_post').textContent = 'par : ' + attributes.auteur_post;
            document.getElementById('contenu_post').textContent = attributes.contenu_post;
            document.getElementById('id_post').value = attributes.id_post;


            const commentairesContainer = document.querySelector('.commentaires_container');
            commentairesContainer.innerHTML = attributes.commentaires.map(commentaire => `
                <div class="commentaire">
                    <p>${commentaire.nom_utilisateur} : ${commentaire.contenu_commentaire}</p>
                </div>
            `).join('');

            if(attributes.createur)
            {
                document.querySelector(".boutons_alter").style.display = 'flex';
            }

            const bouton_retour = document.getElementById('post_bouton_retour');
            bouton_retour.addEventListener('click', function()
            {
                postDisplaySection.style.display = 'none';
                document.querySelector(".boutons_alter").style.display = 'none';
                postsArea.style.display = 'flex';
                postsArea.style.padding = "20px";
                boutonAjout.style.display = '';
                while (commentairesContainer.firstChild)
                {
                    commentairesContainer.removeChild(commentairesContainer.firstChild);
                }
            });

            const bouton_modifier = document.querySelector('.post_bouton_mod');
            bouton_modifier.addEventListener('click', function()
            {
                postDisplaySection.style.display = 'none';
                document.querySelector(".boutons_alter").style.display = 'none';
                alterPost.style.display = 'flex';
                while (commentairesContainer.firstChild)
                {
                    commentairesContainer.removeChild(commentairesContainer.firstChild);
                }

                document.querySelector('#titre_mod').value = attributes.titre_post;
                document.querySelector('#contenu_mod').value = attributes.contenu_post;
                document.querySelector('#id_post').value = attributes.id_post;
            });

            const bouton_supprimer = document.querySelector('.post_bouton_suppr');
            bouton_supprimer.addEventListener('click', function()
            {
                document.querySelector('#id_post_suppr').value = attributes.id_post;
                console.log("Zikette");
            });
        }
    });
});

document.addEventListener('click', function (event)
{
    const boutonAjout = event.target.closest('.bouton_creation_post');
    if (boutonAjout)
    {
        const creationPost = document.querySelector('.creation_post');
        const postsArea = document.querySelector('.posts_area');

        postsArea.style.display = 'none';
        boutonAjout.style.display = 'none';
        creationPost.style.display = 'flex';
    }
});