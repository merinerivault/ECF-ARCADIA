import Route from "./Route.js";

//Définir ici vos routes
export const allRoutes = [
    new Route("/accueil", "Accueil", "/pages/home.html"),
    new Route("/services", "Services", "/pages/services.html"),
    new Route("/habitats", "Habitats", "/pages/habitats.html"),
    new Route("/jungle", "Jungle", "/pages/jungle.html"),
    new Route("/savane", "Savane", "/pages/savane.html"),
    new Route("/marais", "marais", "/pages/marais.html"),
    new Route("/services", "services", "/pages/services.html"),
];
  

//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "Arcadia";