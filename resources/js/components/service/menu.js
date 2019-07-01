const Menu =  [
    { icon: 'dashboard', text: 'Dashboard', path: '/admin/dashboard' },
    { icon: 'group', text: 'User' },
    { icon: 'format_list_bulleted', text: 'Category', path: '/admin/category' },
    { icon: 'assignment_ind', text: 'Resource', path: '/admin/resource' },
    { icon: 'flag', text: 'Country', path: '/admin/country' },
    {
        icon: 'tv',
        'icon-alt': 'keyboard_arrow_down',
        text: 'Series',
        model: false,
        children: [
            { text: 'All Series', path: '/admin/series' },
            { text: 'Playlists', path: '/admin/series/playlists' },
            { text: 'Episodes', path: '/admin/series/episodes' },
        ]
    },
];
// reorder menu
Menu.forEach((item) => {
    if (item.items) {
        item.items.sort((x, y) => {
            let textA = x.title.toUpperCase();
            let textB = y.title.toUpperCase();
            return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
        });
    }
});

export default Menu;
