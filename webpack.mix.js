if (process.env.module) {
    require(`${__dirname}/build/webpack.${process.env.module}.mix.js`);
}
