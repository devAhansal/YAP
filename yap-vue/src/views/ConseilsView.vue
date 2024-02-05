<template>
  <navbar-client routeCurrentName="conseils" />
  <main>
    <div
      class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 flex justify-center items-center flex-wrap"
    >
      <Panel header="Conseil 01" toggleable>
        <p class="m-0">
          Évaluation du Mode de Vie : Choisissez un animal dont les besoins
          correspondent à votre mode de vie. Certains animaux nécessitent plus
          d'exercice, d'attention, ou d'espace que d'autres.
        </p>
      </Panel>
      <br />
      <Panel header="Conseil 02" toggleable>
        <p class="m-0">
          Taille de l'Espace : Considérez la taille de votre domicile. Certains
          animaux, comme les chiens de grande taille, peuvent avoir besoin de
          plus d'espace pour s'épanouir.
        </p>
      </Panel>
      <br />
      <Panel header="Conseil 03" toggleable>
        <p class="m-0">
          Niveau d'Activité : Sélectionnez un animal dont le niveau d'activité
          correspond au vôtre. Certains animaux ont besoin d'exercice quotidien
          tandis que d'autres sont plus adaptés à un style de vie plus
          tranquille.
        </p>
      </Panel>
      <br />


      <Panel header="Conseil 04" toggleable>
        <p class="m-0">
          Disponibilité en Ressources : Évaluez si vous avez les ressources
          nécessaires en termes de temps, d'argent, et d'énergie pour prendre
          soin de l'animal choisi.
        </p>
      </Panel>
      <br />

      <Panel header="Conseil 05" toggleable>
        <p class="m-0">
          Compatibilité Familiale : Considérez la dynamique familiale. Certains
          animaux peuvent être plus adaptés aux enfants, tandis que d'autres
          peuvent nécessiter une attention plus exclusive.
        </p>
      </Panel>
      <br />

      <Panel header="Conseil 06" toggleable>
        <p class="m-0">
          Besoins Spécifiques : Informez-vous sur les besoins spécifiques de
          l'espèce choisie. Certains animaux ont des exigences alimentaires,
          médicales, ou environnementales spécifiques.
        </p>
      </Panel>
      <br />

      <Panel header="Conseil 07" toggleable>
        <p class="m-0">
          Temps Consacré à l'Animal : Évaluer le temps que vous pouvez consacrer
          à l'animal chaque jour. Certains animaux nécessitent plus
          d'interaction et de soins que d'autres.
        </p>
      </Panel>
      <br />

      <Panel header="Conseil 08" toggleable>
        <p class="m-0">
          Envisagez l'Adoption : Si possible, envisagez d'adopter un animal
          auprès d'un refuge ou d'une organisation de sauvetage. Cela offre une
          chance à un animal de trouver un foyer aimant.
        </p>
      </Panel>
    </div>
  </main>
</template>

<script setup>
import NavbarClient from "../components/NavbarClient.vue";
</script>
