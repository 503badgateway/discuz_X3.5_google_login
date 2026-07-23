# Discuz! X3.5 Google登入插件

**Demo: [https://mcbbs.space](https://www.mcbbs.space)**

## 插件介紹

這是一個為Discuz! X3.5開發的Google登入插件，支持PHP 7.4，允許用戶使用Google帳號快速登入論壇。

## 功能特點

- ✅ Google OAuth 2.0 身份驗證
- ✅ 自動創建帳號或綁定現有帳號
- ✅ 支持帳號綁定/解綁
- ✅ 安全的CSRF保護
- ✅ 中英文語言支持
- ✅ 簡潔美觀的界面

## 系統要求

- Discuz! X3.5
- PHP 7.4 或更高版本
- cURL擴展
- MySQL 5.0+

## 安裝步驟

### 1. 上傳插件文件

下载zip後重命名文件，將整個 `googlelogin` 文件夾上傳到論壇的 `source/plugin/` 目錄下。

### 2. 安裝插件

1. 登入Discuz!後台管理面板
2. 進入「應用」→「插件」
3. 找到「Google登入插件」
4. 點擊「安裝」按鈕

### 3. 配置Google OAuth

1. 前往 [Google Cloud Console](https://console.cloud.google.com/)
2. 創建新項目或選擇現有項目
3. 啟用 Google+ API 或 Google People API
4. 創建 OAuth 2.0 憑證（類型：Web應用程式）
5. 設置授權重定向URI：
   ```
   https://yourdomain.com/plugin.php?id=googlelogin&action=callback
   ```
6. 複製 Client ID 和 Client Secret

### 4. 配置插件

1. 在後台進入「應用」→「插件」→「Google登入插件」→「設置」
2. 填入 Google Client ID
3. 填入 Google Client Secret
4. 啟用插件
5. 保存設置
6. 在登入頁面手動放置：

``` html
<!--{if $_G['cache']['plugin']['googlelogin']['enabled']}-->
<style type="text/css">
.google-login-container { margin: 20px 0; text-align: center; border-top: 1px solid #e5e5e5; padding-top: 15px; }
.google-login-btn { display: inline-block; padding: 12px 24px; background-color: #4285f4; color: #ffffff !important; text-decoration: none; border-radius: 4px; font-size: 14px; font-weight: 500; }
.google-login-btn:hover { background-color: #357ae8; }
</style>
<div class="google-login-container">
    <a href=" " class="google-login-btn">
        使用Google帳號登入
    </a>
</div>
<!--{/if}-->
```

## 使用方法

### 用戶登入

用戶可以在登入頁面看到「使用Google帳號登入」按鈕，點擊後會跳轉到Google授權頁面。

### 綁定帳號

已登入的用戶可以在個人資料頁面綁定或解綁Google帳號。

## 文件結構

```
googlelogin/
├── admincp.inc.php              # 管理面板
├── googlelogin.inc.php          # 主模塊文件
├── googlelogin_account.php      # 帳號創建功能
├── googlelogin_bind.php         # 綁定/解綁功能
├── googlelogin_helper.php       # 輔助函數
├── googlelogin_http.php         # HTTP請求函數
├── googlelogin_oauth.php        # OAuth驗證
├── googlelogin_user.php         # 用戶處理
├── googlelogin_utils.php        # 工具函數
├── install.php                  # 安裝腳本
├── uninstall.php                # 卸載腳本
├── discuz_plugin_googlelogin.xml # 插件配置
├── README.md                    # 說明文檔
├── language/                    # 語言文件
│   ├── lang_zh_cn.php          # 中文語言包
│   └── lang_en.php             # 英文語言包
├── table/                       # 數據表類
│   └── table_googlelogin_users.php
└── template/                    # 模板文件
    ├── login_button.htm        # 登入按鈕模板
    ├── profile_bind.htm        # 綁定模板
    └── googlelogin.css         # 樣式表
```

## 數據庫結構

插件會創建以下數據表：

**pre_common_member_google**

| 字段 | 類型 | 說明 |
|------|------|------|
| uid | mediumint(8) | 用戶ID（主鍵） |
| google_id | varchar(100) | Google用戶ID |
| google_email | varchar(255) | Google郵箱 |
| google_name | varchar(100) | Google用戶名 |
| google_avatar | varchar(255) | Google頭像URL |
| bind_time | int(10) | 綁定時間 |
| last_login | int(10) | 最後登入時間 |

## 安全特性

- CSRF Token保護
- State參數驗證
- SSL/TLS加密通訊
- 安全的密碼生成
- SQL注入防護

## 常見問題

### 1. 無法跳轉到Google登入頁面

確認Client ID配置正確，並且重定向URI已在Google Console中正確設置。

### 2. 提示CSRF驗證失敗

可能是Cookie被阻擋，確認瀏覽器允許第三方Cookie。

### 3. 無法創建帳號

確認論壇允許新用戶註冊，並且郵箱地址未被使用。

## 版本更新

### v1.0.0 (2026-07-23)
- 初始版本發布
- 支持Google OAuth 2.0登入
- 支持帳號綁定/解綁
- 中英文語言支持

## 授權協議

MIT License

## 技術支持

如有問題或建議，請聯繫開發者。
