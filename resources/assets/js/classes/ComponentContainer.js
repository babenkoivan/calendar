class ComponentContainer {
    constructor() {
        this.components = {};
    }

    register(name, component) {
        this.components[name] = component;
    }

    get(name) {
        return this.components[name];
    }
}

export default ComponentContainer;