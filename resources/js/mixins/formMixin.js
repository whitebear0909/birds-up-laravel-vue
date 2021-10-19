const formMixin = {
  methods: {
    validateField(inputName, value) {
      return this.validationRules[inputName].rules
        .filter((rule) => {
          const isValid = rule(value);

          if (isValid !== true) {
            return isValid;
          }
        })
        .map((rule) => rule(value));
    },
    validateForm(form) {
      const formErrors = {};
      let formIsValid = true;

      for (let property in form) {
        const errors = this.validateField(property, form[property]);

        if (errors.length) {
          formIsValid = false;
          formErrors[property] = errors[0];
        }
      }

      formErrors.formIsValid = formIsValid;

      return formErrors;
    },
  },
  data: () => ({
    validationRules: {
      username: {
        rules: [
          (value) => !!value || "Username is required",
          (value) =>
            value.length > 1 || "Username must be less than 2 characters.",
        ],
      },
      password: {
        rules: [
          (value) =>
            value.length > 5 || "Password must be less than 6 characters.",
        ],
      },
    },
  }),
};

export default formMixin;
