<template>
    <div class="container">
      <div v-for="item in filteredItems" >
      <p>{{item.name}}</p>
    </div>

    <input type="text" v-model="search">
    </div>
  </template>
  
  <script>

  export default {
    data() {
      return {
        search: '',
     items: [
       {name: 'Stackoverflow', type: 'development'},
       {name: 'Game of Thrones', type: 'serie'},
       {name: 'Jon Snow', type: 'actor'}
     ]
      };
    },
    computed: {
    filteredItems() {
      return this.items.filter(item => {
        //  return item.type.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
        let byName =
              item.name.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            let byDescription =
              item.type.toLowerCase().indexOf(this.search.toLowerCase()) >
              -1;
            if (byName === true) {
              return byName;
            } else if (byDescription === true) {
              return byDescription;
            }
      })
    }
  }
   
  };
  </script>
  