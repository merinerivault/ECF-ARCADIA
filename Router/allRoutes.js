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
];
  

//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "Arcadia";