<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // HTTPリクエストを扱うクラスをインポート
use Illuminate\Support\Facades\Storage; // ストレージ操作用のクラスをインポート
use Intervention\Image\ImageManager; // 画像操作ライブラリ（Intervention Image）のマネージャをインポート
use Intervention\Image\Drivers\Gd\Driver; // GDドライバを使用するためのクラスをインポート

class ImageController extends Controller
{
    // ファイルアップロード画面を表示するメソッド
    public function fileUpload()
    {
        // ビュー 'image-upload.blade.php' を返して表示
        return view('image-upload');
    }

    // アップロードされた画像を処理するメソッド
    public function storeImage(Request $request)
    {
        // 画像ファイルのバリデーションを行う
        $request->validate([
            // 必須、画像形式、許容する拡張子、最大サイズ
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048'],
        ]);

        // アップロードされた画像ファイルを取得
        $image = $request->file('image');

        // ランダムなユニークな名前を生成（衝突を防ぐために乱数を使用）
        $imageName = uniqid(rand() . '_') . '.' . $image->extension();
        
        // 画像をストレージ（'public/images'ディレクトリ）に保存
        Storage::disk('public')->putFileAs('images', $image, $imageName);

        // 保存した画像ファイルの絶対パスを取得
        $storedPath = Storage::disk('public')->path('images/' . $imageName);

        // 画像操作のためのImageManagerをGDドライバで初期化
        $imgManager = new ImageManager(new Driver());

        // 保存した画像を読み込んでIntervention Imageオブジェクトを作成
        $resizedImage = $imgManager->read($storedPath);

        // 画像のサイズを640x360ピクセルにリサイズ
        $resizedImage->resize(640, 360);

        // リサイズ後の画像を同じパスに上書き保存
        $response = $resizedImage->save($storedPath);

        // 処理成功時のリダイレクト処理
        if ($response) {
            return redirect()->back()->with('success', '画像のアップロードに成功しました。'); // 成功メッセージを添えてリダイレクト
        }

        // 処理失敗時のリダイレクト処理
        return redirect()->back()->with('error', '画像のアップロードに失敗しました。'); // 失敗メッセージを添えてリダイレクト
    }
}
