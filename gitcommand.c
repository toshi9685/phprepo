#include<stdio.h>

int main(void){
  printf("git init : ディレクトリをGitリポジトリに登録");
  printf("git status : ワークツリーとインデックスの状態を確認する\n");
  printf("git add <filename>   : インデックスに登録する.スペース区切りで複数指定できる\n");
  printf("git add . : 全てのファイルをインデックスに登録する\n");
  printf("git commit -m \"<コメント>\" : ローカルリポジトリにコミットする\n");
  printf("git log : リポジトリの変更履歴\n");
  printf("git remote add <name> <url> : <name>は登録名(基本的にorigin)<url>はリモートリポジトリのURL\n");
  printf("git push <repository> <refspec>... : <repository>はプッシュ先のアドレス,<refspec>はプッシュするブランチ\n");

  return 0;
}
