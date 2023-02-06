<template>
  <div>
    <h3>Дашборд</h3>

  </div>
</template>

<script>
  export default {
    name: 'Dashboard',

    data() {
      return {
        tableData: [{
          date: '2016-05-03',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-02',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-04',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-01',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-08',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-06',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-07',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }],
        columnsInfo:[{
          label: 'Ім\'я',
          type: 'value',
          width: '',
          tooltip: false,
        }, {
          label: 'Емейл',
          type: 'lang_id',
          width: '',
          tooltip: '',
        }],
      }
    },
  }
</script>
