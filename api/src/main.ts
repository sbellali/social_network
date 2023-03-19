import { NestFactory } from '@nestjs/core';
import { AppModule } from './app.module';

async function bootstrap() {
  const app = await NestFactory.create(AppModule);
  await app.listen(process.env.EXPOSED_PORT ? parseInt(process.env.EXPOSED_PORT) : 3000);
}
bootstrap();
