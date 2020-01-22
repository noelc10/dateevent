import AbsLoading from '@/components/utils/AbsLoading'

export default {
  components: {
    AbsLoading,
  },
  data: () => ({
    loading: false,
  }),
  methods: {
    showLoader() {
      this.loading = true
    },
    hideLoader() {
      this.loading = false
    },
  }
}
