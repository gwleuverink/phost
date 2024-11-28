import print from './helpers/print'
const { shell } = require("electron");

export default {
    print,
    openExternal: shell.openExternal
}
