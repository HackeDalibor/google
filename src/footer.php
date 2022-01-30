    <footer>
        <?php
            // On déclare un tableau (en ouvrant [] ou array())
            $langueElements = [
                "Français", "Anglais", "Serbe", "Allemand", "Alsacien", "Extraterestre"
            ];
            
            function alimenterListeDeroulante($langues)
            // On déclare une fonction personnalisée
            {
                echo "<select name='langues' id='langues'>";
                foreach($langues as $langue){
                    echo "<option value='$langue'>".$langue."</option>";
                }
                echo "</select>";
            }

            alimenterListeDeroulante($langueElements);
            // On renvoie notre fonction
        ?>
        <a href="#" class="foot">Aide</a>
        <a href="#" class="foot">Confidentalité</a>
        <a href="#" class="foot">Conditions d'utilisation</a>
    </footer>