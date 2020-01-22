<template>
  <v-menu ref="menu" v-model="menu" :nudge-right="40" lazy transition="scale-transition" offset-y full-width min-width="290px">
    <template v-slot:activator="{ on }">
      <v-text-field :value="dateValue" :label="label" :error-messages="errorMessages" readonly v-on="on" required></v-text-field>
    </template>
    <v-date-picker v-model="dateValue" :min="minDate" no-title scrollable>
      <v-spacer></v-spacer>
      <v-btn flat color="dark" @click="menu = false">Cancel</v-btn>
      <v-btn flat color="dark" @click="$refs.menu.save(dateValue)">OK</v-btn>
    </v-date-picker>
  </v-menu>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
    },
    label: {
      type: String,
      default: 'Choose Date'
    },
    minDate: {
      type: String
    },
    errorMessages: {
      type: [Object, Array, String]
    }
  },
  data() {
    return {
      menu: false,
      dateValue: this.value
    }
  },
  watch: {
    value(val) {
      this.dateValue = val
    },
    dateValue(val) {
      this.$emit('input', val)
    }
  }
}
</script>

<style>

</style>
