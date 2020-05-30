if (process.env.module) {
    require(`${__dirname}/webpack.${process.env.module}.mix.js`);
}
