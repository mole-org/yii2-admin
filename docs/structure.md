# 数据结构文档

## 系统菜单与权限控制
```
{
    "tab": {
        "label": "系统"
    },
    "menu": {
        "label": "用户管理",
        "items": [{
            "label": "角色管理",
            "route": ["admin-role/index"]
        }]
    },
    "read": ["index", "view"],
    "write": ["create", "update", "delete"]
}
```