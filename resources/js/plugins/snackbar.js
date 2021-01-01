const snackbar = {
    install: (Vue, { store }) => {
        if (!store) {
            throw new Error('Please provide vuex store.');
        }

        Vue.prototype.$snackbar = {
            showMessage: function ({
                content = '',
                color = ''
            }) {
                store.commit(
                    'showMessage',
                    { content, color },
                    { root: true }
                );
            }
        };
    },
};
export default snackbar;