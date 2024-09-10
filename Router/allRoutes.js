import Route from "./Route.js";

//Définir ici vos routes
export const allRoutes = [
    new Route("/accueil", "Accueil", "/pages/home.html"),
    new Route("/services", "Services", "/pages/services.html"),
    new Route("/habitats", "Habitats", "/pages/habitats/habitats.html"),
    new Route("/jungle", "Jungle", "/pages/habitats/jungle.html"),
    new Route("/savane", "Savane", "/pages/habitats/savane.html"),
    new Route("/marais", "marais", "/pages/habitats/marais.html"),
    new Route("/contact", "Contacts", "/pages/contact.html"),
    new Route("/infospratiques", "Infos pratiques", "/pages/infospratiques.html"),
    new Route("/connexion", "Se connecter", "/pages/auth/connexion.html"),
    new Route("/gorille", "Gorille", "/pages/animaux/jungle/gorille.html"),
    new Route("/jaguard", "Jaguard", "/pages/animaux/jungle/jaguard.html"),
    new Route("/python", "Python", "/pages/animaux/jungle/python.html"),
    new Route("/perroquet", "Perroquet", "/pages/animaux/jungle/perroquet.html"),
    new Route("/tigre", "Tigre", "/pages/animaux/jungle/tigre.html"),
];

  

//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "Arcadia";