<template>
  <Card style="width: 20rem; overflow: hidden;" class="ml-4 mb-8">
    <template #header>
      <center>
        <img
          style="max-height: 20rem"
          alt="user header"
          src="https://static0.tiendeo.fr/images/tiendas/260709/catalogos/583091/paginas/jpg_catalogo/00001.jpg?format=webp"
        />
      </center>
    </template>
    <template #title>Saison des soldes</template>
    <template #subtitle>
      <P> Du 25 Janvier au 11 Février</P>
    </template>
    
    <template #footer>
      <Button label="Consulter" severity="info" outlined class="w-full" />
    </template>
  </Card>
</template>

<script setup></script>
