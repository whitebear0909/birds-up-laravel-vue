<template>
  <input class="form-control" type="text" name="daterange" :value="'01/01/' + new Date().getFullYear() + ' - ' + '12/31/' + new Date().getFullYear()" />
</template>

<script>

export default {
    name: 'DateRangePicker',

    data: () => ({
        start: '',
        end: ''
    }),

    mounted() {
        var parent = this;
        $('input[name="daterange"]').daterangepicker(null, function(start, end, label) {
            parent.start = start.format('YYYY-MM-DD');
            parent.end = end.format('YYYY-MM-DD');
            parent.$emit('rangeUpdate', parent.start, parent.end);
        });
    }
}

</script>